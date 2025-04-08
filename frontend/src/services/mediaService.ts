export interface MediaItem {
  id: number
  name: string
  children?: MediaItem[]
  url?: string
  type?: string
  dimmension?: string
  size?: string | number
  photo_by?: string
}

export interface Member {
  name: string
  type: string
  checked: boolean
}

const getMembers = async (): Promise<Member[]> => {
  return [
    { name: 'Admin', type: 'admin', checked: false },
    { name: 'Apple', type: 'apple', checked: false },
  ]
}

const getMediaItems = async (): Promise<MediaItem[]> => {
  return [
    {
      "id": 1,
      "name": "Uploads",
      "children": [
        {
          "id": 10,
          "name": "Images",
          "children": [
            {
              "id": 101,
              "name": "Image 1",
              "children": [
                {
                  "id": 1012,
                  "name": "Seasandiego.jpg",
                  "url": "https://assets.site-static.com/userFiles/2597/image/2023/CARDIFF_BY_THE_SEA/5-23-2023_1__reasons-why-cardiff-by-the-sea-san-diego-great-place-to-live/9_Reasons_Why_Cardiff-by-the-Sea_San_Diego_.jpg",
                  "type": "image/jpg",
                  "dimmension": "2000x2000",
                  "size": "763300",
                  "photo_by": "Admin"
                },
              ]
            },
            {
              "id": 102,
              "name": "iMactwin.png",
              "url": "https://i.insider.com/60e4cb0d22d19400191c957c?width=1000&format=jpeg&auto=webp",
              "type": "image/png",
              "dimmension": "2000x2000",
              "size": "640200",
              "photo_by": "Apple"
            },
            {
              "id": 103,
              "name": "hustlecup.jpg",
              "url": "https://images.deliveryhero.io/image/fd-ph/LH/kmph-hero.jpg",
              "type": "image/jpg",
              "dimmension": "2000x2000",
              "size": "100400",
              "photo_by": "Admin"
            },
            {
              "id": 104,
              "name": "MS-Surface.jpg",
              "url": "https://windowstablet.vn/wp-content/uploads/2021/12/Anh-Dai-Dien-Surface-Pro-8-01-22921.jpg",
              "type": "image/jpg",
              "dimmension": "2000x2000",
              "size": "113200",
              "photo_by": "Admin"
            },
            {
              "id": 105,
              "name": "Famoustower.jpg",
              "url": "https://www.worldfamousthings.com/wp-content/uploads/2018/01/Leaning-Tower-of-Pisa-Italy.jpg",
              "type": "image/jpg",
              "dimmension": "2000x2000",
              "size": "763300",
              "photo_by": "Admin"
            }
          ]
        },
        {
          "id": 20,
          "name": "Document",
          "children": []
        },
        {
          "id": 30,
          "name": "Videos",
          "children": [
            {
              "id": 301,
              "name": "GODZILLA MINUS ONE Official Trailer",
              "url": "https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/330px-No-Image-Placeholder.svg.png?20200912122019",
              "type": "video/mp4",
              "dimmension": "2000x2000",
              "size": "763300",
              "photo_by": "Admin"
            },
            {
              "id": 302,
              "name": "Marvel Studios’ Loki Season 2 | October 6 on Disney+",
              "url": "https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/330px-No-Image-Placeholder.svg.png?20200912122019",
              "type": "video/mp4",
              "dimmension": "2000x2000",
              "size": "763300",
              "photo_by": "Admin"
            },
            {
              "id": 303,
              "name": "THE BOY AND THE HERON | Official Teaser Trailer",
              "url": "https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/330px-No-Image-Placeholder.svg.png?20200912122019",
              "type": "video/mp4",
              "dimmension": "2000x2000",
              "size": "763300",
              "photo_by": "Admin"
            }
          ]
        }
      ]
    },
    {
      "id": 2,
      "name": "Sources",
      "children": []
    },
    {
      "id": 3,
      "name": "Shared",
      "children": []
    }
  ]
}

export default {
  getMembers,
  getMediaItems,
}
