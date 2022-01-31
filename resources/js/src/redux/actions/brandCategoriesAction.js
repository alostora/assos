import { BRAND_CATEGORIES_PAGE_REQUEST, BRAND_CATEGORIES_PAGE_SUCCESS, BRAND_CATEGORIES_PAGE_FAIL, CLEAR_ERRORS } from "../constants/Constants"

import { axiosInstance } from "../../axios/config"

export const getBrandCategories = (brandId) => async (dispatch) => {

    try {

        dispatch({ type: BRAND_CATEGORIES_PAGE_REQUEST })

        const { data } = await axiosInstance({
            method: "get",
            url: `/vendorCategories/${brandId}`,
        })

        dispatch({
            type: BRAND_CATEGORIES_PAGE_SUCCESS,
            payload: data
        })

    }

    catch (error) {
        dispatch({
            type: BRAND_CATEGORIES_PAGE_FAIL,
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
