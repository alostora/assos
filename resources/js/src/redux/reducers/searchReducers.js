
import { SEARCH_PAGE_REQUEST, SEARCH_PAGE_SUCCESS, SEARCH_PAGE_FAIL, CLEAR_ERRORS } from "../constants/Constants"

export const searchReducer = (state = { products: {} }, action) => {

    switch (action.type) {

        case SEARCH_PAGE_REQUEST:
            return {
                loading: true,
                products: {}
                
            }
        case SEARCH_PAGE_SUCCESS:
            return {
                loading: false,
                products: action.payload.items
            }

        case SEARCH_PAGE_FAIL:
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