
import { PRODUCT_DETAILS_REQUEST, PRODUCT_DETAILS_SUCCESS, PRODUCT_DETAILS_FAIL, CLEAR_ERRORS } from "../constants/Constants"

import { axiosInstance } from "../../axios/config"

export const getProductDetails = (productId) => async (dispatch) => {

    try {

        dispatch({ type: PRODUCT_DETAILS_REQUEST })

        const { data } = await axiosInstance({
            method: "get",
            url: `/itemInfo/${productId}`,
        })

        dispatch({
            type: PRODUCT_DETAILS_SUCCESS,
            payload: data
        })

    }

    catch (error) {
        dispatch({
            type: PRODUCT_DETAILS_FAIL,
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
