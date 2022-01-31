import { CATEGORY_ITEMS_PAGE_REQUEST, CATEGORY_ITEMS_PAGE_SUCCESS, CATEGORY_ITEMS_PAGE_FAIL, CLEAR_ERRORS } from "../constants/Constants"

import { axiosInstance } from "../../axios/config"

export const getCategoryItems = (subCategoryId, brandId) => async (dispatch) => {

    try {

        dispatch({ type: CATEGORY_ITEMS_PAGE_REQUEST })

        const { data } = await axiosInstance({
            method: "get",
            url: `/items/${subCategoryId}/${brandId}`,
        })

        dispatch({
            type: CATEGORY_ITEMS_PAGE_SUCCESS,
            payload: data
        })

    }

    catch (error) {
        dispatch({
            type: CATEGORY_ITEMS_PAGE_FAIL,
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
