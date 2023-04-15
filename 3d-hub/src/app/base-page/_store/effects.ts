import { UserEffects } from './user/effects';
import { SettingEffects } from './setting/effects';
import { TeamEffects } from './team/effects';
import { CartEffects } from './cart/effects';
import { FolderEffects } from './folder/effects';
import { NotificationEffects } from './notification/effects';
import { TemplateEffects } from './template/effects';
import { DraftTemplateEffects } from './drafttemplate/effects';
import { DocumentEffects } from './document/effects';

export const effects: any[] = [
  UserEffects,
  FolderEffects,
  SettingEffects,
  TeamEffects,
  CartEffects,
  NotificationEffects,
  TemplateEffects,
  DraftTemplateEffects,
  DocumentEffects,
];
