import { Routes, RouterModule} from '@angular/router';
import { DashboardComponent } from './_components/dashboard/dashboard.component';
import { PostComponent } from './_components/post/post.component';
import { LayoutComponent } from './_layout/layout/layout.component';
import { AdminComponent } from './_components/admin/admin.component';
import { AddComponent } from './_components/admin/post/add/add.component';
import { ListComponent } from './_components/admin/post/list/list.component';
import { CategoryComponent } from './_components/admin/post/category/category.component';
import { ListCategoryComponent } from './_components/admin/post/category/list-category/list-category.component';

const appRoutes : Routes = [

   { path: '', component: AdminComponent, pathMatch: 'full' },
   { path: 'dashboard', component: DashboardComponent },
   { path: 'addpost', component: AddComponent },
   { path: 'editpost/:id', component: AddComponent },
   { path: 'addCategory', component: CategoryComponent },
   { path: 'editCategory/:id', component: CategoryComponent },
   { path: 'posts', component: ListComponent },
   { path : 'manage-category', component: ListCategoryComponent},
    {
        path : '', 
        component : LayoutComponent,
        children : [
            { path: 'post', component: PostComponent },
            { path: ':posturl', component: PostComponent },
           
           // { path: 'dashboard', component: DashboardComponent,canActivate:[AuthGuard] }
        ]
    
    }
    
//    {path: 'login', component: LoginComponent },

];

export const Route = RouterModule.forRoot(appRoutes);