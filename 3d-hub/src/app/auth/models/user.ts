import { Role } from './role';

export class User {
  id?: number;
  email?: string;
  password?: string;
  fullName?: string;
  username?: string;
  roles?: Array<Role>;
  accessToken?: string;
  phone?: string;
  avatarUrl?: string;
  organizationId?: string;
}
