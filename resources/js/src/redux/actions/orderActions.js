
import { ORDER_REQUEST, ORDER_SUCCESS, ORDER_FAIL, CLEAR_ERRORS } from "../constants/Constants"

import { axiosInstance } from "../../axios/config"

export const getOrder = () => async (dispatch) => {

    try {

        dispatch({ type: ORDER_REQUEST })

        const { data } = await axiosInstance({
            method: "get",
            url: `/getOrder`,
        })

        dispatch({
            type: ORDER_SUCCESS,
            payload: data
        })

    }

    catch (error) {
        dispatch({
            type: ORDER_FAIL,
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
