import { MediaFile } from '../file';

export interface TemplateModel {
  id: string;

  owner: any;

  docType: DocType;

  conType: ETemplateContentType;

  name: string;

  brief: string;

  description: string;

  keywords: Array<string>;

  version: number;

  isPremium: boolean;

  onceTimePurchasePrice: number;

  files: Array<MediaFile>;

  fonts: TemplateFont[];

  status: ETemplateStatus;

  isDelete: boolean;

  updatedAt: string;

  createdAt: string;

  groupKey?: number;
}

export enum ETemplateStatus {
  draft = 'draft',
  published = 'published',
  submit = 'submit_global',
  rejectSubmit = 'reject_submit',
  approvalSubmit = 'approval_submit',
}

export interface TemplateMaterial {
  id?: string;
}

export interface TemplateFont {
  id?: string;
}

export enum ETemplateContentType {
  background = 'background',
  layout = 'layout',
  group = 'group',
}
export interface DocType {
  id: string;
  name: string;
  slug: string;
  width: number;
  height: number;
  unit: EDocTypeUnit;
  description: string;
  brief: string;
  tags: Array<string>;
  priority: number;
  status: EDocTypeStatus;
  isDelete: boolean;
  updatedAt: string;
  createdAt: string;
}

export enum EDocTypeStatus {
  draft = 'draft',
  published = 'published',
}

export enum EDocTypeUnit {
  in = 'in',
  pixel = 'px',
  pint = 'pt',
  centimet = 'cm',
}
