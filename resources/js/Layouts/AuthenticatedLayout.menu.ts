type Role = 'company' | 'artist';

interface Menu {
  name: string;
  route: string;
}

export const getMenus = (role: Role): Menu[] => {
  const menus: Record<Role, Menu[]> = {
    company: [
      { name: 'Dashboard', route: route('dashboard') },
      { name: 'ArtList', route: route('art.index') },
      { name: 'Profile', route: route('profile.edit') },
      { name: 'Chat', route: route('chat.index') },
    ],
    artist: [
      { name: 'Dashboard', route: route('dashboard') },
      { name: 'Art', route: route('art.register') },
      { name: 'Profile', route: route('profile.edit') },
    ]
  };

  return menus[role];
}