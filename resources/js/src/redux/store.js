import { createStore, combineReducers, applyMiddleware } from 'redux'

import thunk from 'redux-thunk'

import { composeWithDevTools } from 'redux-devtools-extension'

import { homeReducer } from './reducers/homeReducers'

import { productDetailsReducer } from './reducers/productDetailsReducers'

import { searchReducer } from './reducers/searchReducers'

import { brandCategoriesReducer } from './reducers/brandCategoriesReducers'

import { favoriteItemsReducer } from './reducers/favoriteReducers'

import { orderReducer } from './reducers/orderReducers'

import { subCategoriesReducer } from './reducers/subCategoriesReducers'

import { categoryItemsReducer } from './reducers/categoryItemsReducers'

import { authReducer } from './reducers/userReducers'

import { addressReducer } from './reducers/addressReducers'


const reducer = combineReducers({

    homePage: homeReducer,
    productDetails: productDetailsReducer,
    searchProducts: searchReducer,
    brandCategories: brandCategoriesReducer,
    favoriteItems: favoriteItemsReducer,
    order: orderReducer,
    subCategories: subCategoriesReducer,
    categoryItems: categoryItemsReducer,
    auth: authReducer,
    address: addressReducer,
})

let initialState = {}

const middleware = [thunk]

const store = createStore(reducer, initialState, composeWithDevTools(applyMiddleware(...middleware)))

export default store;