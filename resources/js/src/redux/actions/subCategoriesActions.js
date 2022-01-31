import { SUB_CATEGORIES_PAGE_REQUEST, SUB_CATEGORIES_PAGE_SUCCESS, SUB_CATEGORIES_PAGE_FAIL, CLEAR_ERRORS } from "../constants/Constants"

import { axiosInstance } from "../../axios/config"

export const getSubCategories = (categoryId, brandId) => async (dispatch) => {

    try {

        dispatch({ type: SUB_CATEGORIES_PAGE_REQUEST })

        const { data } = await axiosInstance({
            method: "get",
            url: `/vendorSubCats/${categoryId}/${brandId}`,
        })

        dispatch({
            type: SUB_CATEGORIES_PAGE_SUCCESS,
            payload: data
        })

    }

    catch (error) {
        dispatch({
            type: SUB_CATEGORIES_PAGE_FAIL,
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
