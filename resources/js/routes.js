import CategoriesComponent from './components/CategoriesComponent';
import CategoryCreate from './components/admin-components/category/Create';
import ProductCreate from './components/admin-components/product/Create';
import CategoryManager from './components/admin-components/category/Manage';
import CategoryEdit from './components/admin-components/category/Edit';
import ProductManager from './components/admin-components/product/Manage';
import ProductEdit from './components/admin-components/product/Edit';
import UserManager from './components/admin-components/user/Manage';

export default [

        {
            path: '/categories/create',
            name: 'Category create',
            component: CategoryCreate
        },
        {
            path: '/products/create',
            name: 'Product create',
            component: ProductCreate
        },
        {
            path: '/categories',
            name: 'Category management',
            component: CategoryManager
        },
        {
            path: '/categories/edit/:id',
            name: 'Category edit',
            component: CategoryEdit
        },
        {
            path: '/products',
            name: 'Product management',
            component: ProductManager
        },
        {
            path: '/products/edit/:id',
            name: 'Product edit',
            component: ProductEdit
        },
        {
            path: '/users',
            name: 'User management',
            component: UserManager
        },
    ]