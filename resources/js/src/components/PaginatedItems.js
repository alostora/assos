//react
import React, { useEffect, useState, Fragment } from 'react';
import ReactPaginate from 'react-paginate';

//translate
import { useTranslation } from "react-i18next";

//component
import Item from './Item';


const Items = ({ currentItems }) => {
    return (
        <div className="items row mx-0 mb-2">

            {currentItems && currentItems.map(it => (

                <div className='col-lg-3 col-6 mb-2' key={it.id}>

                    <Item item={it} />
                </div>
            ))}


        </div>
    );
}

const PaginatedItems = ({ items, itemsPerPage }) => {
    // We start with an empty list of items.
    const [currentItems, setCurrentItems] = useState(null);
    const [pageCount, setPageCount] = useState(0);
    // Here we use item offsets; we could also use page offsets
    // following the API or data you're working with.
    const [itemOffset, setItemOffset] = useState(0);

    useEffect(() => {
        // Fetch items from another resources.
        const endOffset = itemOffset + itemsPerPage;
        //console.log(`Loading items from ${itemOffset} to ${endOffset}`);
        setCurrentItems(items.slice(itemOffset, endOffset));
        setPageCount(Math.ceil(items.length / itemsPerPage));
    }, [itemOffset, itemsPerPage, items]);

    // Invoke when user click to request another page.
    const handlePageClick = (event) => {
        const newOffset = (event.selected * itemsPerPage) % items.length;
        // console.log(
        //     `User requested page number ${event.selected}, which is offset ${newOffset}`
        // );
        setItemOffset(newOffset);
    };

    //translate
    const { t } = useTranslation();

    return (
        <Fragment>
            <Items currentItems={currentItems} />
            <ReactPaginate
                nextLabel={t("Next")}
                previousLabel={t("Pervious")}
                breakLabel="..."
                marginPagesDisplayed={2}    // number of pages in end paginated
                pageRangeDisplayed={2}      // number of pages in breakLabel
                pageCount={pageCount}
                onPageChange={handlePageClick}
                containerClassName='pagination justify-content-center mt-4'
                pageClassName='page-item'
                pageLinkClassName='page-link'
                previousClassName="page-item"
                previousLinkClassName="page-link"
                nextClassName="page-item"
                nextLinkClassName="page-link"
                breakClassName="page-item"
                breakLinkClassName="page-link"
                activeClassName="active"
                renderOnZeroPageCount={null}
            />
        </Fragment>
    );
}

export default PaginatedItems;