
import { BRAND_CATEGORIES_PAGE_REQUEST, BRAND_CATEGORIES_PAGE_SUCCESS, BRAND_CATEGORIES_PAGE_FAIL, CLEAR_ERRORS } from "../constants/Constants"

export const brandCategoriesReducer = (state = { brandCategories: {} }, action) => {

    switch (action.type) {

        case BRAND_CATEGORIES_PAGE_REQUEST:
            return {
                loading: true,
                brandCategories: {}
                
            }
        case BRAND_CATEGORIES_PAGE_SUCCESS:
            return {
                loading: false,
                brandCategories: action.payload.data
            }

        case BRAND_CATEGORIES_PAGE_FAIL:
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