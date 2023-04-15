import { ActionReducerMap, createFeatureSelector } from '@ngrx/store';
export interface ItemState {
}

export const reducers: ActionReducerMap<ItemState> = {
};

export const selectContainerState = createFeatureSelector<ItemState>('itemStore');
