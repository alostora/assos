// icons material-ui
import HomeOutlinedIcon from '@mui/icons-material/HomeOutlined';
import { grey } from '@mui/material/colors';
import CheckRoundedIcon from '@mui/icons-material/CheckRounded';
import { green } from '@mui/material/colors';

//translate
import { useTranslation } from "react-i18next";

//react
import React, { useState, useEffect, Fragment } from "react"
import { Link, useLocation } from "react-router-dom";
import { Form } from 'react-bootstrap'

// redux
import { useDispatch, useSelector } from 'react-redux'
import { getSearchProducts } from '../../redux/actions/searchActions'

//components
import Loader from "../../components/Loader"
import PaginatedItems from '../../components/PaginatedItems';


const Search = ({ categories, brands, properties, sortType }) => {
    //translate
    const { t } = useTranslation();

    // filter search 
    const [minPrice, setMinPrice] = useState(1)
    const [maxPrice, setMaxPrice] = useState(1000)

    const [categoryFilterId, setCategoryFilterId] = useState([])

    const [brandFilterId, setBrandFilterId] = useState([])

    const [propertiesFilterId, setPropertiesFilterId] = useState([])

    const [sortTypeFilter, setSortTypeFilter] = useState("priceASC")

    //from url
    const { search } = useLocation();

    const searchText = search.substring(9).replace(" ", "_")
    /////////////////////////////////////////////////////////////////////

    // fetch from api
    const dispatch = useDispatch()

    const { loading, error } = useSelector(state => state.searchProducts)

    const { products } = useSelector(state => state.searchProducts)

    const searchItems = products ? products.data : [];


    const [searchData, setSearchData] = useState({})

    useEffect(() => {

        dispatch(getSearchProducts(searchData))

    }, [dispatch, searchData, error])


    useEffect(() => {

        setSearchData({
            itemNameSearch: searchText,
            vendor_id: brandFilterId,
            cats_ids: categoryFilterId,
            sub_prop_ids: propertiesFilterId,
            sub_cat_ids: [],
            minPrice: minPrice,
            maxPrice: maxPrice,
            sortType: sortTypeFilter
        })

    }, [searchText, brandFilterId, categoryFilterId, propertiesFilterId, minPrice, maxPrice, sortTypeFilter])

    return (
        <div className="search-page d-flex flex-column py-4 container">

            <div className="d-flex align-items-center page-names mb-4" >
                <HomeOutlinedIcon style={{ color: grey[500] }} className="me-2" />
                <Link
                    to="/"
                    className="text-decoration-none">

                    <span className="page-name">{t("Home")}</span>
                </Link>

            </div>
            {/* /////////////////////////////////////////////////////////////////////// */}

            <div className="search-section row ">

                <div className="d-flex flex-column filters col-12 col-lg-3">

                    <div className="category d-flex flex-column mt-3">

                        <span >{t("Category")}</span>

                        <div className="category-checkbox">

                            {categories && categories.map(cat => (

                                <Form.Check
                                    type="checkbox"
                                    id="default-checkbox"
                                    label={cat.categoryName}
                                    className="pt-2"
                                    key={cat.id}
                                    value={cat.id}
                                    onChange={(e) => {

                                        if (e.target.checked) {

                                            let newFilter = [...categoryFilterId, cat.id]
                                            setCategoryFilterId([...new Set(newFilter)])

                                        } else {
                                            setCategoryFilterId(
                                                categoryFilterId.filter(id => id !== cat.id)
                                            )
                                        }
                                    }}
                                />

                            ))}

                        </div>
                    </div>
                    {/* ///////////////////////////// */}

                    <div className="category d-flex flex-column mt-3">

                        <span >{t("Brand")}</span>

                        <div className="category-checkbox  ">
                            {brands && brands.map(brand => (

                                <Form.Check
                                    type="checkbox"
                                    id="default-checkbox"
                                    label={brand.vendor_name}
                                    className="pt-2"
                                    key={brand.id}
                                    value={brand.id}
                                    onChange={(e) => {

                                        if (e.target.checked) {

                                            let newFilter = [...brandFilterId, brand.id]
                                            setBrandFilterId([...new Set(newFilter)])

                                        } else {
                                            setBrandFilterId(
                                                brandFilterId.filter(id => id !== brand.id)
                                            )
                                        }
                                    }}
                                />

                            ))}
                        </div>
                    </div>
                    {/* ///////////////////////////// */}

                    <div className="category d-flex flex-column my-3">

                        <span >{t("Size")}</span>


                        <div className="d-flex flex-column diff-size pt-3">

                            <div className='d-flex'>
                                {properties && properties.clothes_size && properties.clothes_size.map(it => (
                                    <button key={it.id} onClick={() => {

                                        if (!propertiesFilterId.includes(it.id)) {

                                            let newFilter = [...propertiesFilterId, it.id]
                                            setPropertiesFilterId([...new Set(newFilter)])

                                        } else {
                                            setPropertiesFilterId(
                                                propertiesFilterId.filter(id => id !== it.id)
                                            )
                                        }

                                    }}

                                        className={`btn-size ${propertiesFilterId.includes(it.id) ? "btn-size-active" : ""} `}>

                                        {it.propertyName.charAt(0).toUpperCase()}</button>
                                ))}
                            </div>

                            <div className='d-flex mt-3'>

                                {properties && properties.shoes_size && properties.shoes_size.map(it => (
                                    <button key={it.id} onClick={() => {

                                        if (!propertiesFilterId.includes(it.id)) {

                                            let newFilter = [...propertiesFilterId, it.id]
                                            setPropertiesFilterId([...new Set(newFilter)])

                                        } else {
                                            setPropertiesFilterId(
                                                propertiesFilterId.filter(id => id !== it.id)
                                            )
                                        }

                                    }}

                                        className={`btn-size ${propertiesFilterId.includes(it.id) ? "btn-size-active" : ""} `}>

                                        {it.propertyName}</button>
                                ))}

                            </div>
                        </div>

                    </div>
                    {/* ///////////////////////////// */}

                    <div className="category d-flex flex-column mt-3">

                        <span >{t("Color")}</span>
                        <div className="d-flex diff-color">

                            {properties && properties.color && properties.color.map(it => (
                                <div className='d-flex flex-column' key={it.id}>

                                    <button
                                        className={`btn-color d-flex `}
                                        onClick={() => {

                                            if (!propertiesFilterId.includes(it.id)) {

                                                let newFilter = [...propertiesFilterId, it.id]
                                                setPropertiesFilterId([...new Set(newFilter)])

                                            } else {
                                                setPropertiesFilterId(
                                                    propertiesFilterId.filter(id => id !== it.id)
                                                )
                                            }
                                        }}
                                        style={{ backgroundColor: `${it.propertyName}` }}>

                                    </button>

                                    <div>

                                        {propertiesFilterId.includes(it.id) ?
                                            < CheckRoundedIcon sx={{ color: green[500] }} fontSize='large' />
                                            : null}
                                    </div>

                                </div>

                            ))}
                        </div>

                    </div>
                    {/* ///////////////////////////// */}

                    <div className="category d-flex flex-column mt-4">

                        <span >{t("Price")}</span>
                        <div className="filter-price mt-2">
                            <div className="d-flex align-items-center mb-3">
                                <Form.Control
                                    type="number"
                                    placeholder={t("SAR")}
                                    value={minPrice}
                                    onChange={(e) => setMinPrice(e.target.value)}
                                />
                                <span className="mx-2">{t("to")}</span>
                                <Form.Control
                                    type="number"
                                    placeholder={t("SAR")}
                                    value={maxPrice}
                                    onChange={(e) => setMaxPrice(e.target.value)}
                                />
                            </div>
                            {/* <Form.Range  onChange={(e)=> console.log(e.target.value)} /> */}
                            <span className="d-flex justify-content-center ">
                                {t("From")}<span className="px-2"><span className="ps-1">{minPrice} </span> {t("SAR")}</span>
                                <span>{t("to")}</span>
                                <span className="px-2"><span className="ps-1">{maxPrice} </span>{t("SAR")}</span>
                            </span>

                        </div>
                    </div>
                    {/* ///////////////////////////// */}

                    <div className='category d-flex flex-column mt-4'>

                        <span className='text-nowrap'>{t("Sort by")}</span>

                        <Form.Select className='mt-2'

                            onChange={(e) => setSortTypeFilter(e.target.value)}
                        >

                            {sortType && sortType.map(it => (

                                <option key={it.id} value={it.sortKeyName}>{it.sortTypeName}</option>
                            ))}

                        </Form.Select>
                    </div>
                    {/* ///////////////////////////// */}

                </div>
                {/* /////////////////////////////////////////////////////////////////////// */}

                <Fragment>
                    {loading ? <Loader /> :

                        <div className="search-result d-flex flex-column col-12 col-lg-9">

                            <div className="d-flex header my-4 ">
                                <span>{searchItems && searchItems.length} <span className="px-2">{t("search results")}</span> </span>

                            </div>

                            {searchItems && searchItems.length > 0 &&

                                <PaginatedItems items={searchItems} itemsPerPage={4} />
                            }

                        </div>
                    }
                </Fragment>
            </div>

        </div>
    )
}

export default Search;