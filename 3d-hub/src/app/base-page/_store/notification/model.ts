export interface NotificationModel {
  id?: number;
  type: string;

  title?: string;
  content: string;
  seen?: boolean;

  userId?: number;
  userFullName?: string;

  objectId: number;
  objectType: string;

  createdByFullName: string;
  createdById: number;
  createdTime: string;
}

export interface EventOnsignal {
  content: string;
  data: NotificationModel;
  heading: string;
  icon: string;
  id: string;
}
