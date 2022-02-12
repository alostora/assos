//react
import React, { useEffect, Fragment } from 'react'
import { useTranslation } from "react-i18next";
import { Link, useParams } from 'react-router-dom';

//redux
import { useDispatch, useSelector } from 'react-redux'
import { getCategoryItems } from '../../redux/actions/categoryItemsActions'

//icons material-ui
import HomeOutlinedIcon from '@mui/icons-material/HomeOutlined';
import ArrowBackIosOutlinedIcon from '@mui/icons-material/ArrowBackIosOutlined';
import { grey } from '@mui/material/colors';

//component
import PaginatedItems from '../../components/PaginatedItems';
import Loader from '../../components/Loader';


const CategoryItems = () => {

    //translate
    const { t } = useTranslation();

    // fetch from api
    const dispatch = useDispatch()

    const {
        subCategory_name: subCategoryName,
        category_name: categoryName,
        brand_name: brandName,
        subCategory_id: subCategoryId,
        brand_id: brandId,
        category_id: categoryId,
    } = useParams();

    const { loading, categoryItems, error } = useSelector(state => state.categoryItems)


    const items = categoryItems ? categoryItems.data : [];

    useEffect(() => {

        dispatch(getCategoryItems(subCategoryId, brandId))

    }, [dispatch, error, subCategoryId, brandId])



    return (
        <Fragment>
            {loading ? <Loader /> :

                <div className='category-items-page d-flex flex-column my-4'>

                    <div className="d-flex align-items-center page-names container mb-4">

                        <Link to="/" className="text-decoration-none d-flex align-items-center ">
                            <HomeOutlinedIcon style={{ color: grey[500] }} />
                            <span className="page-name mx-1">{t("Home")}</span>
                        </Link>

                        <ArrowBackIosOutlinedIcon fontSize="medium" style={{ color: grey[300] }} />

                        <Link to={`/brands-categories/${brandName}/${brandId}`} className="text-decoration-none ">
                            <span className="page-name ">{brandName}</span>
                        </Link>


                        <ArrowBackIosOutlinedIcon fontSize="medium" style={{ color: grey[300] }} />

                        <Link to={`/sub-categories/${categoryName}/${brandName}/${categoryId}/${brandId}`}
                            className="text-decoration-none ">
                            <span className="page-name ">{categoryName}</span>
                        </Link>

                        <ArrowBackIosOutlinedIcon fontSize="medium" style={{ color: grey[300] }} />

                        <span className="page-name ">{subCategoryName}</span>

                    </div>

                    <div>

                        <div className="recent-items container ">

                            {items && items.length > 0 &&

                                <PaginatedItems items={items} itemsPerPage={4} />
                            }

                        </div>

                    </div>

                </div>
            }
        </Fragment >
    )
}

export default CategoryItems;