<template>
  <ul class="menu-list">
    <li v-for="(item, index) in items" :key="item.id">
      <div
          @click="item.children && toggle(item.id)"
          :class="{ expanded: expanded[item.id] }"
          class="menu-item"
          v-if="item.children"
      >
        <svg
            v-if="item.children"
            class="arrow-icon"
            :class="{ rotated: expanded[item.id] }"
            viewBox="0 0 24 24"
        >
          <path d="M8 5v14l11-7z" fill="currentColor" />
        </svg>

        <svg class="folder-icon" viewBox="0 0 24 24">
          <path
              :d="expanded[item.id] ? openFolderPath : closedFolderPath"
              fill="currentColor"
          />
        </svg>

        <span class="menu-text" @click="$emit('selectFolder', item)">{{ item.name }}</span>
        <span class="menu-text menu-test-count">{{ countLeafItems(item.children) }}</span>
      </div>
      <MediaFolderMultiLevel
          v-if="item.children && expanded[item.id]"
          :items="item.children"
          @selectFolder="$emit('selectFolder', item)"
          class="submenu"
      />
    </li>
  </ul>
</template>

<script setup lang="ts">
import { ref, defineProps } from 'vue'
import type { MediaItem } from '../services/mediaService'

defineProps<{ items: MediaItem[] }>()

const expanded = ref<Record<number, boolean>>({})
const toggle = (index: number) => {
  expanded.value[index] = !expanded.value[index]
}
const countLeafItems = (items: MediaItem[]): number => {
  let count = 0

  for (const item of items) {
    if (item.children) {
      count += countLeafItems(item.children)
    } else {
      count += 1
    }
  }

  return count
}

const openFolderPath = 'M10 4H2v16h20V6H12l-2-2z'
const closedFolderPath = 'M10 4H2v16h20V6H12l-2-2z'
</script>

<style scoped>
.menu-list {
  list-style: none;
  padding-left: 0;
}
.menu-item {
  cursor: pointer;
  padding: 4px 8px;
}
.submenu {
  padding-left: 16px;
}
.menu-item {
  cursor: pointer;
  padding: 4px 8px;
  display: flex;
  align-items: center;
  gap: 6px;
}

.arrow-icon {
  width: 30px;
  height: 30px;
  transition: transform 0.2s ease;
}
.arrow-icon.rotated {
  transform: rotate(270deg);
}

.folder-icon {
  width: 16px;
  height: 16px;
}

.menu-text {
  flex-grow: 1;
}
.menu-item.expanded {
  color: #2b7cf9;
}

.menu-item.expanded .arrow-icon,
.menu-item.expanded .folder-icon {
  color: #2b7cf9;
  fill: #2b7cf9;
}
</style>
