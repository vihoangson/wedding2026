import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useWeddingStore = defineStore('wedding', () => {
  // State
  const couple = ref({
    brideName: 'Nguyễn Thủy',
    groomName: 'Trần Minh'
  })

  const weddingDate = ref(new Date(2026, 7, 15))

  const venue = ref({
    ceremony: 'Nhà thờ Thánh Mary, Quận Hà Đông',
    reception: 'Nhà hàng Tiệc Cưới Hoa Anh Đào'
  })

  const rsvpList = ref([])

  // Actions
  const addRSVP = (rsvpData) => {
    rsvpList.value.push(rsvpData)
  }

  const getRSVPCount = () => {
    return rsvpList.value.length
  }

  return {
    couple,
    weddingDate,
    venue,
    rsvpList,
    addRSVP,
    getRSVPCount
  }
})

