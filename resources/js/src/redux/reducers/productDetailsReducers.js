
import { PRODUCT_DETAILS_REQUEST, PRODUCT_DETAILS_SUCCESS, PRODUCT_DETAILS_FAIL, CLEAR_ERRORS } from "../constants/Constants"

export const productDetailsReducer = (state = { productDetails: {} }, action) => {

    switch (action.type) {

        case PRODUCT_DETAILS_REQUEST:
            return {
                loading: true,
                productDetails: {}
                
            }
        case PRODUCT_DETAILS_SUCCESS:
            return {
                loading: false,
                productDetails: action.payload.item
            }

        case PRODUCT_DETAILS_FAIL:
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