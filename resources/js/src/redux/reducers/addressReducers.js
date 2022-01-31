import { GET_ADDRESS_REQUEST, GET_ADDRESS_SUCCESS, GET_ADDRESS_FAIL, CLEAR_ERRORS } from "../constants/Constants"

export const addressReducer = (state = { address: [] }, action) => {

    switch (action.type) {

        case GET_ADDRESS_REQUEST:
            return {
                loading: true,
                address: []

            }

        case GET_ADDRESS_SUCCESS:
            return {
                loading: false,
                address: action.payload.address
            }

        case GET_ADDRESS_FAIL:
            return {
                loading: false,
                address: action.payload.address,
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