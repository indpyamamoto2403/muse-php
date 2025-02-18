import { faHome, faUser, faCog, faComments, faPalette } from '@fortawesome/free-solid-svg-icons'
import { IconDefinition } from '@fortawesome/fontawesome-svg-core'

type Role = 'company' | 'artist'

interface Menu {
  name: string
  route: string
  icon: IconDefinition
}

export const getMenus = (role: Role): Menu[] => {
  const menus: Record<Role, Menu[]> = {
    company: [
      { name: 'Dashboard', route: route('dashboard'), icon: faHome },
      { name: 'ArtList', route: route('art.index'), icon: faPalette },
      { name: 'Profile', route: route('profile.edit'), icon: faUser },
      { name: 'Chat', route: route('chat.index'), icon: faComments },
    ],
    artist: [
      { name: 'Dashboard', route: route('dashboard'), icon: faHome },
      { name: 'Art', route: route('art.register'), icon: faPalette },
      { name: 'Profile', route: route('profile.edit'), icon: faUser },
    ]
  }

  return menus[role]
}
