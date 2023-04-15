import { MediaFile } from '../file';

export interface DocumentModel {
  id: string;

  owner: any;

  docType: DocType;

  conType: EDocumentContentType;

  name: string;

  brief: string;

  description: string;

  keywords: Array<string>;

  version: number;

  isPremium: boolean;

  onceTimePurchasePrice: number;

  files: Array<MediaFile>;

  fonts: DocumentFont[];

  status: EDocumentStatus;

  isDelete: boolean;

  updatedAt: string;

  createdAt: string;

  groupKey?: number;
}

export enum EDocumentStatus {
  draft = 'draft',
  published = 'published',
  submit = 'submit_global',
  rejectSubmit = 'reject_submit',
  approvalSubmit = 'approval_submit',
}

export interface DocumentMaterial {
  id?: string;
}

export interface DocumentFont {
  id?: string;
}

export enum EDocumentContentType {
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
