
import { SUB_CATEGORIES_PAGE_REQUEST, SUB_CATEGORIES_PAGE_SUCCESS, SUB_CATEGORIES_PAGE_FAIL, CLEAR_ERRORS } from "../constants/Constants"

export const subCategoriesReducer = (state = { subCategories: [] }, action) => {

    switch (action.type) {

        case SUB_CATEGORIES_PAGE_REQUEST:
            return {
                loading: true,
                subCategories: []
                
            }
        case SUB_CATEGORIES_PAGE_SUCCESS:
            return {
                loading: false,
                subCategories: action.payload.sub_cats
            }

        case SUB_CATEGORIES_PAGE_FAIL:
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