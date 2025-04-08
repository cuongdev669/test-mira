<script setup lang="ts">
import { ref, computed, reactive, onMounted, watch } from 'vue'
import mediaService from './../services/mediaService'
import MediaFolderMultiLevel from './MediaFolderMultiLevel.vue'
import type { MediaItem, Member } from '../services/mediaService'

const searchQuery = ref('')
const searchMember = ref<Member[]>([])
const maxSizePlan = ref(2)
const selectedFolder = ref<MediaItem | null>(null)
const bytesToKB = (bytes: number) => (bytes / 1024).toFixed(1)
const members = ref<Member[]>([])
const mediaItems = ref([])

onMounted(async () => {
  members.value = await mediaService.getMembers()
  mediaItems.value = await mediaService.getMediaItems()
  selectedFolder.value = mediaItems.value[0]
})

watch(
    members,
    (newMembers) => {
      searchMember.value = newMembers.filter(member => member.checked)
    },
    { deep: true }
)

const selectFolder = (menuItems: MediaItem[]) => {
  selectedFolder.value = menuItems
}

const displayItems = computed(() => {
  if (!selectedFolder.value) return []

  const flattenItems = (folder: MediaItem): MediaItem[] => {
    let results: MediaItem[] = []
    if (!folder.children) {
      results.push(folder)
    } else {
      folder.children.forEach(child => {
        results = results.concat(flattenItems(child))
      })
    }
    return results
  }

  let items = flattenItems(selectedFolder.value)

  const selectedMembers = searchMember.value.map(m => m.name)
  if (selectedMembers.length > 0) {
    items = items.filter(item => selectedMembers.includes(item.photo_by))
  }

  if (searchQuery.value.trim() !== '') {
    const keyword = searchQuery.value.toLowerCase()
    items = items.filter(item => item.name.toLowerCase().includes(keyword))
  }

  return items
})

function searchLeafItems(items: MediaItem[]): MediaItem[] {
  const result: MediaItem[] = []

  for (const item of items) {
    if (item.children && item.children.length > 0) {
      result.push(...searchLeafItems(item.children))
    } else {
      // const matches = keyword === '' || item.name.toLowerCase().includes(keyword.toLowerCase())
      if (!item.children) {
        result.push(item)
      }
    }
  }
  return result
}

const usedStoragePercent = computed(() => {
  const maxSize = maxSizePlan.value * 1024 * 1024 * 1024 // 2GB in bytes

  function collectLeafItems(items) {
    let result = []

    for (const item of items) {
      const hasChildren = Array.isArray(item.children) && item.children.length > 0

      if (hasChildren) {
        result = result.concat(collectLeafItems(item.children))
      } else if (item.size !== undefined && !isNaN(Number(item.size))) {
        result.push(item)
      }
    }
    return result
  }

  const leafItems = collectLeafItems(mediaItems.value || [])
  const totalSize = leafItems.reduce((sum, item) => sum + Number(item.size), 0)

  return Number(((totalSize / maxSize) * 100).toFixed(1))
})
const filterByMember = (members: Member[]) => {
  members.forEach(member => {
    member.checked = true
  })
  searchMember.value = [...members]
}
</script>

<template>
  <div class="container">
    <div class="sidebar">
      <div class="import-documents">
        <button type="button">Import Documents</button>
      </div>
      <div class="storage-box">
        <div class="info-row">
          <span class="info-left">Storage</span>
          <span class="info-right link">Change plan</span>
        </div>
        <div class="storage-bar">
          <div class="storage-progress" :style="{ width: usedStoragePercent + '%' }"></div>
        </div>
        <div class="storage-percent">
          <span class="current-percent">{{ usedStoragePercent }}%</span> used of {{ maxSizePlan }}GB
        </div>
      </div>

      <div class="search-box">
        <div class="info-row">
          <span class="info-left">Search</span>
        </div>
        <input type="text" v-model="searchQuery" placeholder="e.g. image.png" class="search-input" />
      </div>

      <div class="folders">
        <div class="info-row">
          <span class="info-left">Folders</span>
          <span class="info-right link">New folder</span>
        </div>
        <MediaFolderMultiLevel :items="mediaItems" @selectFolder="selectFolder" />
      </div>

      <div class="member-filter">
        <div class="info-row">
          <span class="info-left">Members</span>
          <span class="info-right link" @click="filterByMember(members)">Select all</span>
        </div>
        <label v-for="member in members" :key="member.name">
          <input type="checkbox" v-model="member.checked" /> {{ member.name }}
        </label>
      </div>
    </div>

    <div class="main-content">
      <div class="media-table">
        <table class="media-table-el">
          <thead>
          <tr>
            <th><input type="checkbox" /></th>
            <th>Select all</th>
            <th>Name</th>
            <th>Dimmension</th>
            <th>Size</th>
          </tr>
          </thead>
          <tbody v-if="displayItems.length">
            <tr v-for="(item, index) in displayItems" :key="index">
              <td><input type="checkbox" /></td>
              <td><img :src="item.url" :alt="item.url" class="thumb-img" /></td>
              <td>{{ item.name }}</td>
              <td>{{ item.dimmension }}</td>
              <td>{{ bytesToKB(item.size) }} kB</td>
            </tr>
          </tbody>
          <p v-else>No item is selected</p>
        </table>
      </div>
    </div>
  </div>
</template>

<style scoped>
.container {
  display: flex;
  height: 100vh;
  font-family: "Noto Sans JP", sans-serif;
  font-size: 18px;
  background-color: #f5f7fa;
  border: 1px solid #ccc;
}

.sidebar {
  width: 260px;
  background-color: #ffffff;
  padding: 16px;
  border-right: 1px solid #e2e8f0;
  border-radius: 12px 0 0 12px;
}
.sidebar .import-documents button {
  background: #0091be;
  color: #fff;
  border-radius: 1px;
}

.storage-box {
  margin-bottom: 25px;
  padding-bottom: 25px;
  border-bottom: 1px solid #ccc;
  padding-top: 20px;
}
.storage-box .info-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 6px;
}

.storage-box .info-left {
  font-size: 14px;
  color: #2d3748;
  font-weight: 500;
}

.storage-box .info-right {
  font-size: 14px;
  color: #4a5568;
}

.link {
  color: #3182ce;
  cursor: pointer;
  text-decoration: underline;
}
.storage-bar {
  background-color: #e2e8f0;
  height: 8px;
  border-radius: 10px;
  overflow: hidden;
}
.storage-progress {
  height: 8px;
  background-color: #4299e1;
  border-radius: 10px;
}
.storage-percent {
  font-size: 16px;
  color: #718096;
  margin-top: 4px;
  font-weight: bold;
}
.storage-percent .current-percent {
  color: #2b7cf9;
}

.search-box {
  margin-bottom: 40px;
  padding-bottom: 40px;
  border-bottom: 1px solid #ccc;
}

.search-box .info-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 6px;
}

.search-box .info-left {
  font-size: 14px;
  color: #2d3748;
  font-weight: 500;
}

.search-input {
  width: 89%;
  padding: 10px;
  border: 1px solid #cbd5e0;
  border-radius: 8px;
  font-size: 14px;
}

.folders {
  margin-bottom: 25px;
  padding-bottom: 25px;
  border-bottom: 1px solid #ccc;
}
.folders .info-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 6px;
}

.folders .info-left {
  font-size: 14px;
  color: #2d3748;
  font-weight: 500;
}

.folders .info-right {
  font-size: 14px;
  color: #4a5568;
}

.member-filter {
  margin-top: 12px;
  padding: 10px;
}

.member-filter label {
  display: block;
  margin-bottom: 8px;
  color: #2d3748;
}

.member-filter .info-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 6px;
}
.member-filter .info-left {
  font-size: 14px;
  color: #2d3748;
  font-weight: 500;
}

.member-filter .info-right {
  font-size: 14px;
  color: #4a5568;
}
.member-filter label {
  display: block;
  float: left;
  width: 100%;
  text-align: left;
}

.main-content {
  min-width: 1018px;
  flex: 1;
  padding: 16px;
  overflow-y: auto;
  background-color: #ffffff;
  border-radius: 0 12px 12px 0;
}

.media-table-el {
  width: 100%;
  border-collapse: collapse;
  overflow: hidden;
}

.media-table-el th, .media-table-el td {
  border: 1px solid #e2e8f0;
  padding: 8px;
  text-align: left;
  font-size: 15px;
  font-weight: 600;
}

.thumb-img {
  width: 300px;
  height: 100px;
  object-fit: cover;
  border-radius: 4px;
}
</style>