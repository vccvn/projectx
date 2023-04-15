import { SettingsActions, SettingActionsTypes } from './actions';
import { SettingModel } from './model';

export interface State {
  server: {
    loading?: boolean;
    data?: SettingModel[];
  };
}

export const initialState: State = {
  server: {
    loading: false,
    data: []
  }
};

export function reducer(state = initialState, action: SettingsActions): State {
  switch (action.type) {
    case SettingActionsTypes.GET_SETTINGS: {
      return {
        ...state,
        ...{ server: { loading: true } }
      };
    }

    case SettingActionsTypes.GET_SETTINGS_SUCCESS: {
      const server = {
        ...state.server,
        ...{ ...action.payload.data, loading: false }
      };

      return {
        ...state,
        ...{ server }
      };
    }

    case SettingActionsTypes.GET_SETTINGS_FAILURE: {
      return {
        ...state,
        ...{ server: { loading: false } }
      };
    }

    default:
      return state;
  }
}
