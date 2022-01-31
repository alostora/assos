
import { LOGIN_REQUEST, LOGIN_SUCCESS, LOGIN_FAIL, CLEAR_ERRORS } from "../constants/Constants"

import { REGISTER_REQUEST, REGISTER_SUCCESS, REGISTER_FAIL } from "../constants/Constants"

import { USER_PROFILE_REQUEST, USER_PROFILE_SUCCESS, USER_PROFILE_FAIL } from "../constants/Constants"

import { LOGOUT_SUCCESS, LOGOUT_FAIL } from "../constants/Constants"

import { SOCIAL_SIGNUP_REQUEST, SOCIAL_SIGNUP_SUCCESS, SOCIAL_SIGNUP_FAIL } from "../constants/Constants"

import { UPDATE_PROFILE_REQUEST, UPDATE_PROFILE_SUCCESS } from "../constants/Constants"


export const authReducer = (state = { user: {} }, action) => {

    switch (action.type) {

        case LOGIN_REQUEST:
        case REGISTER_REQUEST:
        case USER_PROFILE_REQUEST:
        case SOCIAL_SIGNUP_REQUEST:
            return {
                loading: true,
                isAuthenticated: false,

            }

        case UPDATE_PROFILE_REQUEST:
            return {
                loading: true,
                isAuthenticated: true,
            }

        case LOGIN_SUCCESS:
        case REGISTER_SUCCESS:
        case USER_PROFILE_SUCCESS:
        case SOCIAL_SIGNUP_SUCCESS:
        case UPDATE_PROFILE_SUCCESS:
            return {
                loading: false,
                isAuthenticated: action.payload.status,
                user: action.payload.user,
                message: action.payload.message || null
            }

        case LOGOUT_SUCCESS:
            return {
                loading: false,
                isAuthenticated: false,
                user: null,
            }

        case LOGIN_FAIL:
        case REGISTER_FAIL:
        case LOGOUT_FAIL:
        case SOCIAL_SIGNUP_FAIL:
            return {
                loading: false,
                isAuthenticated: action.payload.status,
                user: null,
                error: action.payload.message
            }

        case USER_PROFILE_FAIL:
            return {
                loading: false,
                isAuthenticated: false,
                user: null,
                error: action.payload.message
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