
import { HOME_PAGE_REQUEST, HOME_PAGE_SUCCESS, HOME_PAGE_FAIL, CLEAR_ERRORS } from "../constants/Constants"


export const homeReducer = (state = { home: {} }, action) => {


    switch (action.type) {

        case HOME_PAGE_REQUEST:
            return {
                loading: true,
                homePage: {}
            }
        case HOME_PAGE_SUCCESS:
            return {
                loading: false,
                homePage: action.payload.data
            }

        case HOME_PAGE_FAIL:
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