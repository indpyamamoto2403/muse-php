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
      { name: 'Profile', route: 'profile' },
    ],
    artist: [
      { name: 'Dashboard', route: route('dashboard') },
      { name: 'Art', route: route('art.register') },
      { name: 'Profile', route: 'profile' },
    ]
  };

  return menus[role];
}