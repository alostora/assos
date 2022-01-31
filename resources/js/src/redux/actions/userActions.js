import { LOGIN_REQUEST, LOGIN_SUCCESS, LOGIN_FAIL, CLEAR_ERRORS } from "../constants/Constants"

import { REGISTER_REQUEST, REGISTER_SUCCESS, REGISTER_FAIL } from "../constants/Constants"

import { USER_PROFILE_REQUEST, USER_PROFILE_SUCCESS, USER_PROFILE_FAIL } from "../constants/Constants"

import { LOGOUT_SUCCESS, LOGOUT_FAIL } from "../constants/Constants"

import { SOCIAL_SIGNUP_REQUEST, SOCIAL_SIGNUP_SUCCESS, SOCIAL_SIGNUP_FAIL } from "../constants/Constants"

import { UPDATE_PROFILE_REQUEST, UPDATE_PROFILE_SUCCESS, UPDATE_PROFILE_FAIL } from "../constants/Constants"


import { axiosInstance } from "../../axios/config"

//login
export const login = (email, password) => async (dispatch) => {

    try {

        dispatch({ type: LOGIN_REQUEST })

        const { data } = await axiosInstance({
            method: "post",
            url: `/login`,
            data: {
                email: email,
                password: password,
            }
        })

        dispatch({
            type: LOGIN_SUCCESS,
            payload: data
        })

    }

    catch (error) {
        dispatch({
            type: LOGIN_FAIL,
            payload: error
        })
    }

}

// register
export const register = (userData) => async (dispatch) => {

    try {

        dispatch({ type: REGISTER_REQUEST })

        const { data } = await axiosInstance({
            method: "post",
            url: `/register`,
            data: userData
        })

        dispatch({
            type: REGISTER_SUCCESS,
            payload: data
        })

    }

    catch (error) {
        dispatch({
            type: REGISTER_FAIL,
            payload: error
        })
    }

}


//get user profile
export const getUserProfile = () => async (dispatch) => {

    try {

        dispatch({ type: USER_PROFILE_REQUEST })

        const { data } = await axiosInstance({
            method: "get",
            url: `/profile`,
        })

        dispatch({
            type: USER_PROFILE_SUCCESS,
            payload: data
        })

    }

    catch (error) {
        dispatch({
            type: USER_PROFILE_FAIL,
            payload: error
        })
    }

}

//logout
export const logout = () => async (dispatch) => {

    try {

        const { data } = await axiosInstance({
            method: "get",
            url: `/logOut`,
        })

        dispatch({
            type: LOGOUT_SUCCESS,
            payload: data
        })

    }

    catch (error) {
        dispatch({
            type: LOGOUT_FAIL,
            payload: error
        })
    }

}

// social sign up
export const socialSignUp = (userData) => async (dispatch) => {

    try {

        dispatch({ type: SOCIAL_SIGNUP_REQUEST })

        const { data } = await axiosInstance({
            method: "post",
            url: `/socialSignUp`,
            data: userData
        })

        dispatch({
            type: SOCIAL_SIGNUP_SUCCESS,
            payload: data
        })

    }

    catch (error) {
        dispatch({
            type: SOCIAL_SIGNUP_FAIL,
            payload: error
        })
    }

}

// update profile
export const updateProfile = (userData) => async (dispatch) => {

    try {

        dispatch({ type: UPDATE_PROFILE_REQUEST })

        const { data } = await axiosInstance({
            method: "post",
            url: `/updateProfile`,
            data: userData
        })

        dispatch({
            type: UPDATE_PROFILE_SUCCESS,
            payload: data
        })

    }

    catch (error) {
        dispatch({
            type: UPDATE_PROFILE_FAIL,
            payload: error
        })
    }

}


//clear errors 

export const clearErrors = () => async (dispatch) => {

    dispatch({
        type: CLEAR_ERRORS
    })
}
