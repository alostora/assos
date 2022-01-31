import { FAVORITE_ITEMS_REQUEST , FAVORITE_ITEMS_SUCCESS, FAVORITE_ITEMS_FAIL, CLEAR_ERRORS } from "../constants/Constants"

import { axiosInstance } from "../../axios/config"

export const getFavoriteItems = () => async (dispatch) => {

    try {

        dispatch({ type: FAVORITE_ITEMS_REQUEST })

        const { data } = await axiosInstance({
            method: "get",
            url: `/userItemsFav`,
        })

        dispatch({
            type: FAVORITE_ITEMS_SUCCESS,
            payload: data
        })

    }

    catch (error) {
        
        dispatch({
            type: FAVORITE_ITEMS_FAIL,
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
