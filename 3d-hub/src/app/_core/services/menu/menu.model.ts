export interface MenuIcon {
  type: 'class' | 'icon' | 'img';
  value: string;
  theme?: 'outline' | 'twotone' | 'fill';
  spin?: boolean;
  twoToneColor?: string;
  iconfont?: string;
}

export interface Menu {
  [key: string]: any;
  text: string;
  i18n?: string;
  group?: boolean;
  link?: string;

  linkExact?: boolean;
  externalLink?: string;
  target?: '_blank' | '_self' | '_parent' | '_top';
  icon?: string | MenuIcon | null;
  badge?: number;
  badgeDot?: boolean;
  badgeStatus?: string;
  disabled?: boolean;
  hide?: boolean;
  hideInBreadcrumb?: boolean;
  acl?: any;
  shortcut?: boolean;
  shortcutRoot?: boolean;
  reuse?: boolean;
  open?: boolean;
  children?: Menu[];
}

export const menuData = [
  {
    title: 'Dashboard',
    path: 'dashboard',
    icon: 'bar-chart',
    roles: ['ROLE_ADMIN', 'ROLE_AGENCY', 'ROLE_AFFILIATE'],
    childs: [
      {
        title: 'Overview',
        path: 'overview',
        icon: 'radar-chart',
        roles: ['ROLE_ADMIN', 'ROLE_AGENCY', 'ROLE_AFFILIATE']
      },
      {
        title: 'Analysis',
        path: 'analysis',
        icon: 'radar-chart',
        roles: ['ROLE_ADMIN', 'ROLE_AGENCY']
      },
      {
        title: 'Report',
        path: 'report',
        icon: 'radar-chart',
        roles: ['ROLE_ADMIN', 'ROLE_AGENCY']
      }
    ]
  },

  {
    title: 'Telco',
    path: '',
    icon: 'global',
    roles: ['ROLE_ADMIN'],
    childs: [
      {
        title: 'Telcos',
        path: 'telcos',
        icon: 'bank',
        roles: ['ROLE_ADMIN', 'ROLE_AGENCY']
      },
      {
        title: 'Telco Categories',
        path: 'payment-packages',
        icon: 'bank',
        roles: ['ROLE_ADMIN', 'ROLE_AGENCY']
      }
    ]
  },

  {
    title: 'SIM',
    path: 'sims',
    icon: 'pages',
    roles: ['ROLE_AGENCY', 'ROLE_AFFILIATE', 'ROLE_ADMIN'],
    childs: [
      {
        title: 'Sims',
        path: 'sims',
        roles: ['ROLE_ADMIN']
      },
      {
        title: 'Sims Agency',
        path: 'sims-agency',
        roles: ['ROLE_AGENCY']
      },
      {
        title: 'Sims Affiliate',
        path: 'sims-affiliate',
        roles: ['ROLE_AFFILIATE']
      },
      {
        title: 'Sim Categories',
        path: 'simcategories',
        roles: ['ROLE_AGENCY', 'ROLE_ADMIN']
      },
      {
        title: 'Sims Reservations',
        path: 'sims-affiliate-reservations',
        roles: ['ROLE_AFFILIATE']
      },
      {
        title: 'Sim Categories',
        path: 'simcategories',
        roles: ['ROLE_AFFILIATE']
      }
    ]
  },

  {
    title: 'Agency',
    path: 'agencies',
    icon: 'user',

    roles: ['ROLE_ADMIN'],
    childs: [
      {
        title: 'Agencies List',
        path: 'agencies',
        roles: ['ROLE_ADMIN']
      },
      {
        title: 'Agencies Approval',
        path: 'agencies-approval',
        roles: ['ROLE_ADMIN']
      }
    ]
  },
  {
    title: 'Sub Agency',
    path: 'sub-agencies',
    icon: 'user',
    roles: ['ROLE_AGENCY']
  },
  {
    title: 'E-Commerce',
    path: 'ecommerce',
    icon: 'shop',
    roles: ['ROLE_AFFILIATE', 'ROLE_AGENCY'],
    childs: [
      {
        title: 'Orders Waiting',
        icon: 'shopping-cart',
        path: 'agency-orders-waiting',
        roles: ['ROLE_AGENCY']
      },
      {
        title: 'Orders',
        icon: 'shopping-cart',
        path: 'agency-orders',
        roles: ['ROLE_AGENCY']
      },
      {
        title: 'Carts',
        icon: 'shopping-cart',
        path: 'affiliate-carts',
        roles: ['ROLE_AFFILIATE']
      }
    ]
  },

  {
    title: 'Affiliate',
    path: 'affiliates',
    icon: 'team',
    roles: ['ROLE_ADMIN'],
    childs: [
      {
        title: 'Affiliates List',
        path: 'affiliates',
        roles: ['ROLE_ADMIN']
      },
      {
        title: 'Affiliates Approval',
        path: 'affiliates-approval',
        roles: ['ROLE_ADMIN']
      }
    ]
  },

  {
    title: 'Messages',
    path: 'messages',
    icon: 'message',
    roles: ['ROLE_ADMIN']
  },

  {
    title: 'Pages',
    path: 'cms-pages',
    icon: 'copy',
    roles: ['ROLE_ADMIN'],
    childs: [
      { title: 'Page List', path: 'cms-pages', roles: ['ROLE_ADMIN'] },
      { title: 'New Page', path: 'cms-pages/item', roles: ['ROLE_ADMIN'] }
    ]
  },

  {
    title: 'Posts',
    path: 'cms-posts',
    icon: 'copy',
    roles: ['ROLE_ADMIN'],
    childs: [
      { title: 'Post List', path: 'cms-posts', roles: ['ROLE_ADMIN'] },
      { title: 'New Post', path: 'cms-posts/item', roles: ['ROLE_ADMIN'] }
    ]
  },

  {
    title: 'Location',
    path: '/pages',
    icon: 'compass',
    roles: ['ROLE_ADMIN'],
    childs: [
      { title: 'Ward', path: 'wards', roles: ['ROLE_ADMIN'] },
      { title: 'District', path: 'districts', roles: ['ROLE_ADMIN'] },
      { title: 'Province', path: 'provinces', roles: ['ROLE_ADMIN'] }
    ]
  },

  {
    title: 'Reports',
    path: 'reports',
    icon: 'fund',
    roles: ['ROLE_ADMIN', 'ROLE_AGENCY', 'ROLE_AFFILIATE'],
    childs: [
      { title: 'Report', path: 'reports2', roles: ['ROLE_ADMIN'] },
      { title: 'Report', path: 'report-agencies', roles: ['ROLE_AGENCY'] },
      {
        title: 'Invoices',
        icon: 'file',
        path: 'affiliate-invoices',
        roles: ['ROLE_AFFILIATE']
      }
    ]
  },

  {
    title: 'Settings',
    path: '/page/settings',
    icon: 'setting',
    roles: ['ROLE_ADMIN'],
    childs: [
      { title: 'Genaral', path: 'settings/genaral', roles: ['ROLE_ADMIN'] }
    ]
  }
];
