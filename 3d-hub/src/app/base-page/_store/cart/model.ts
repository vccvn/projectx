export interface CartModel {
  id?: number;
  simId?: number;
  customer?: CustomerModel;
  customerName?: string;
  customerPhone?: string;
  customerAddress?: string;
  createdBy?: { id: number; fullName: string };
  reservations?: Array<string>;
  subPrice?: number;
  status?: string;
}

export interface CustomerModel {
  id?: number;
  address?: string;
  phone?: string;
  name?: string;
  email?: string;
}
