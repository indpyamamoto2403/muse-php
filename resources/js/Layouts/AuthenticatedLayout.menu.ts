import { faHome, faUser, faCog, faComments, faPalette, faBacon, faHeart, faQuestion, faLock, faImage, faMicrophone, faDatabase } from '@fortawesome/free-solid-svg-icons'
import { IconDefinition } from '@fortawesome/fontawesome-svg-core'

type Role = 'company' | 'artist' | 'admin'

interface Menu {
  name: string
  route: string
  icon: IconDefinition
}

// Common menu items shared across roles
const commonMenus: Menu[] = [
  { name: 'Dashboard', route: route('dashboard'), icon: faHome },
  { name: 'Profile', route: route('profile.edit'), icon: faUser },
  { name: 'Conversations', route: route('conversations.index'), icon: faComments },
  { name: 'Settings', route: route('settings.index'), icon: faCog },
]

// Specific menu items for each role
const roleSpecificMenus: Record<Role, Menu[]> = {
  company: [
    { name: 'ArtList', route: route('art.index'), icon: faPalette },
    { name: 'Favorite', route: route('art.favorite'), icon: faHeart },
    { name: 'Saved', route: route('art.saved'), icon: faDatabase },
    { name: 'AI', route: route('chat.index'), icon: faMicrophone },
    { name: 'AIQuestions', route: route('chat.questions'), icon: faQuestion },
    { name: 'ImageQuestions', route: route('questions.image.answer'), icon: faImage },
  ],
  artist: [
    { name: 'Art', route: route('art.register'), icon: faPalette },
    { name: 'お気に入り', route: route('art.favorite'), icon: faHeart },
  ],
  admin: [
    { name: 'Art', route: route('art.register'), icon: faPalette },
    { name: 'ArtList', route: route('art.index'), icon: faPalette },
    { name: 'Favorite', route: route('art.favorite'), icon: faHeart },
    { name: 'Saved', route: route('art.saved'), icon: faDatabase },
    { name: 'AI', route: route('chat.index'), icon: faMicrophone },
    { name: 'AIQuestions', route: route('chat.questions'), icon: faHome },
    { name: 'Questions', route: route('questions.index'), icon: faQuestion },
    { name: 'ImageQuestions', route: route('questions.image.answer'), icon: faImage },
    { name: 'ImageQuestionsRegister', route: route('questions.image.register'), icon: faLock },
  ]
}

export const getMenus = (role: Role): Menu[] => {
  return [...commonMenus, ...roleSpecificMenus[role]]
}