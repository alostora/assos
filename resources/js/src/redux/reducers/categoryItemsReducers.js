
import { CATEGORY_ITEMS_PAGE_REQUEST, CATEGORY_ITEMS_PAGE_SUCCESS, CATEGORY_ITEMS_PAGE_FAIL, CLEAR_ERRORS } from "../constants/Constants"

export const categoryItemsReducer = (state = { categoryItems: {} }, action) => {

    switch (action.type) {

        case CATEGORY_ITEMS_PAGE_REQUEST:
            return {
                loading: true,
                categoryItems: {}
                
            }
        case CATEGORY_ITEMS_PAGE_SUCCESS:
            return {
                loading: false,
                categoryItems: action.payload.items
            }

        case CATEGORY_ITEMS_PAGE_FAIL:
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