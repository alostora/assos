
import { SEARCH_PAGE_REQUEST, SEARCH_PAGE_SUCCESS, SEARCH_PAGE_FAIL, CLEAR_ERRORS } from "../constants/Constants"

import { axiosInstance } from "../../axios/config"

export const getSearchProducts = (searchData) => async (dispatch) => {

    try {

        dispatch({ type: SEARCH_PAGE_REQUEST })

        const { data } = await axiosInstance({
            method: "post",
            url: `/itemSearch`,
            data: searchData 
        })

        dispatch({
            type: SEARCH_PAGE_SUCCESS,
            payload: data
        })

    }

    catch (error) {
        dispatch({
            type: SEARCH_PAGE_FAIL,
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
