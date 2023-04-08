const products = [
    {
        'id': 1,
        'name': 'Medium Stout',
        'category': 'guinness',
        'costprice': 2350,
        'sellingprice': 3000,
        'image': '',
        'quantity': 500
    },
    {
        'id': 2,
        'name': 'Star',
        'category': 'nbc',
        'costprice': 2350,
        'sellingprice': 3000,
        'image': '',
        'quantity': 500
    },
    {
        'id': 3,
        'name': 'Hero',
        'category': 'hero',
        'costprice': 2350,
        'sellingprice': 3000,
        'image': '',
        'quantity': 500
    },
    {
        'id': 4,
        'name': 'Malta',
        'category': 'guinness',
        'costprice': 2300,
        'sellingprice': 3000,
        'image': '',
        'quantity': 500
    },
    
]

export default products


const routes = [
    {
        'name': 'Dashboard',
        'link': 'dashboard'
    },

    
    {
        'name': 'New Stock',
        'link': 'addStockTable'
    },

    {
        'name': 'Update Stock',
        'link': 'updateTable'
    },
    {
        'name': 'Stock Report',
        'link': 'stocksReport'
    },

       
    {
        'name': 'Sales Report',
        'link': 'salesReport'
    },


    {
        'name': 'Sales Report By Date',
        'link': 'salesReportByProduct'
    },



    {
        'name': 'Current Stock',
        'link': 'stocks'
    },

    {
        'name': 'Out of Stock',
        'link': 'outStocks'
    },

    {
        'name': 'New Empties',
        'link': 'newEmpties'
    },

    {
        'name': 'Empties',
        'link': 'stocksEmpties'
    },

    {
        'name': 'Products',
        'link': 'products'
    },

    {
        'name': 'New Product',
        'link': 'NewProduct'
    },


]

export const menuLinks = routes