
import { ORDER_REQUEST, ORDER_SUCCESS, ORDER_FAIL, CLEAR_ERRORS } from "../constants/Constants"

export const orderReducer = (state = { order: {} }, action) => {

    switch (action.type) {

        case ORDER_REQUEST:
            return {
                loading: true,
                order: {}
                
            }
        case ORDER_SUCCESS:
            return {
                loading: false,
                order: action.payload.order
            }

        case ORDER_FAIL:
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