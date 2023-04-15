export enum TeamWorkingStatus {
  IDLE = 'idle',
  WORKING = 'working',
}
export interface TeamModel {
  id?: number;
  name?: string;
  teamSize?: number;
  address?: string;
  addressFull?: string;
  phone?: string;
  phone2?: string;
  workingStatus?: TeamWorkingStatus;
  memberIds?: Array<number>;
  rating?: number;

  leaderId?: number;
  leaderFullName?: string;
  projectId?: number;
  projectName?: string;
  futureProjectId?: number;
  futureProjectName?: string;
  provinceId?: number;
  provinceName?: string;
  districtId?: number;
  districtName?: string;

  createdById?: number;
  createdByFullName?: string;
  createdTime?: string;

  updatedById?: number;
  updatedByFullName?: string;
  updatedTime?: string;
}
