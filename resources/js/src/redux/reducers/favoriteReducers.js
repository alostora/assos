
import { FAVORITE_ITEMS_REQUEST , FAVORITE_ITEMS_SUCCESS, FAVORITE_ITEMS_FAIL, CLEAR_ERRORS } from "../constants/Constants"

export const favoriteItemsReducer = (state = { favoriteItems: [] }, action) => {

    switch (action.type) {

        case FAVORITE_ITEMS_REQUEST:
            return {
                loading: true,
                favoriteItems: []
                
            }
        case FAVORITE_ITEMS_SUCCESS:
            return {
                loading: false,
                favoriteItems: action.payload.items
            }

        case FAVORITE_ITEMS_FAIL:
            return {
                loading: false,
                error: action.payload.status
            }

        case CLEAR_ERRORS:
            return {
                ...state,
                error: null
            }
        default:
            return state
    }
}