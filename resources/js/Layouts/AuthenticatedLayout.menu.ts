import { faHome, faUser, faCog, faComments, faPalette, faBacon, faHeart, faQuestion } from '@fortawesome/free-solid-svg-icons'
import { IconDefinition } from '@fortawesome/fontawesome-svg-core'

type Role = 'company' | 'artist' | 'admin'

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
      { name: 'Favorite', route: route('art.favorite'), icon: faHeart },
      { name: 'Profile', route: route('profile.edit'), icon: faUser },
      { name: 'AI', route: route('chat.index'), icon: faBacon },
      { name: 'AIQuestions', route: route('chat.questions'), icon: faQuestion },
      { name: 'Conversations', route: route('conversations.index'), icon: faComments },
      { name: 'Settings', route: route('settings.index'), icon: faCog },
    ],
    artist: [
      { name: 'Dashboard', route: route('dashboard'), icon: faHome },
      { name: 'Art', route: route('art.register'), icon: faPalette },
      { name: 'お気に入り', route: route('art.favorite'), icon: faHeart },
      { name: 'Profile', route: route('profile.edit'), icon: faUser },
      { name: 'Conversations', route: route('conversations.index'), icon: faComments },
      { name: 'Settings', route: route('settings.index'), icon: faCog },
    ],
    admin:[
      { name: 'Dashboard', route: route('dashboard'), icon: faHome },
      { name: 'Art', route: route('art.register'), icon: faPalette },
      { name: 'ArtList', route: route('art.index'), icon: faPalette },
      { name: 'Favorite', route: route('art.favorite'), icon: faHeart },
      { name: 'Profile', route: route('profile.edit'), icon: faUser },
      { name: 'AI', route: route('chat.index'), icon: faBacon },
      { name: 'AIQuestions', route: route('chat.questions'), icon: faQuestion },
      { name: 'Conversations', route: route('conversations.index'), icon: faComments },
      { name: 'Questions', route: route('questions.index'), icon: faQuestion },
      { name: 'Settings', route: route('settings.index'), icon: faCog },
    ]
  }
  
  return menus[role]
}
