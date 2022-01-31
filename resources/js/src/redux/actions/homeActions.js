
import { HOME_PAGE_REQUEST, HOME_PAGE_SUCCESS, HOME_PAGE_FAIL, CLEAR_ERRORS } from "../constants/Constants"

import { axiosInstance } from "../../axios/config"

export const getHomePage = () => async (dispatch) => {

    try {

        dispatch({ type: HOME_PAGE_REQUEST })

        const { data } = await axiosInstance({
            method: "get",
            url: `/home`,
        })

        dispatch({
            type: HOME_PAGE_SUCCESS,
            payload: data
        })

    }

    catch (error) {
        dispatch({
            type: HOME_PAGE_FAIL,
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
