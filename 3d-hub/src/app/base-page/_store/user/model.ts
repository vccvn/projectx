export interface UserModel {
  id?: number;
  fullName?: string;
  email?: string;
  password?: string;
  avatarExtId?: string;
  phone?: string;
  avatarUrl?: string;
  username?: string;
  enabled?: boolean;
  authorityIds?: Array<number>;
  createdTime?: string;
}

export interface PasswordModel {
  currentPassword: string;
  newPassword: string;
}
