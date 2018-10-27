import { Routes, RouterModule} from '@angular/router';
import { DashboardComponent } from './_components/dashboard/dashboard.component';
import { PostComponent } from './_components/post/post.component';
import { LayoutComponent } from './_layout/layout/layout.component';
import { AdminComponent } from './_components/admin/admin.component';
import { AddComponent } from './_components/admin/post/add/add.component';
import { ListComponent } from './_components/admin/post/list/list.component';
import { CategoryComponent } from './_components/admin/post/category/category.component';
import { ListCategoryComponent } from './_components/admin/post/category/list-category/list-category.component';
import { AuthGuard } from './_auth/auth.guard';
import { AccountComponent } from './_components/account/account.component';
import { HeaderAdminComponent } from './_layout/header-admin/header-admin.component';

const appRoutes : Routes = [

   { path: '', component: AccountComponent, pathMatch: 'full' },
   { path: 'dashboard', component: DashboardComponent },
  
    {
        path : '', 
        component : LayoutComponent,
        children : [
            { path: 'post', component: PostComponent },
            { path: ':posturl', component: PostComponent },
           
           // { path: 'dashboard', component: DashboardComponent,canActivate:[AuthGuard] }
        ]
    
    },
    {
        path : 'admin', 
        component : HeaderAdminComponent,
        children : [
            { path: 'addpost', component: AddComponent, canActivate:[AuthGuard]},
            { path: 'editpost/:id', component: AddComponent, canActivate:[AuthGuard]},
            { path: 'addCategory', component: CategoryComponent,canActivate:[AuthGuard] },
            { path: 'editCategory/:id', component: CategoryComponent,canActivate:[AuthGuard] },
            { path: 'posts', component: ListComponent,canActivate:[AuthGuard] },
            { path : 'manage-category', component: ListCategoryComponent,canActivate:[AuthGuard]},
        ]
    
    }
    
//    {path: 'login', component: LoginComponent },

];

export const Route = RouterModule.forRoot(appRoutes);