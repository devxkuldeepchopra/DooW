import { Routes, RouterModule} from '@angular/router';
import { DashboardComponent } from './_components/dashboard/dashboard.component';
import { PostComponent } from './_components/post/post.component';
import { LayoutComponent } from './_layout/layout/layout.component';
import { AdminComponent } from './_components/admin/admin.component';
import { AddComponent } from './_components/admin/post/add/add.component';
import { ListComponent } from './_components/admin/post/list/list.component';
import { CategoryComponent } from './_components/admin/post/category/category.component';

const appRoutes : Routes = [

   {path: '', component: AdminComponent, pathMatch: 'full' },
   { path: 'dashboard', component: DashboardComponent },
   { path: 'addpost', component: AddComponent },
   { path: 'addCategory', component: CategoryComponent },
   { path: 'editpost/:id', component: AddComponent },
   { path: 'posts', component: ListComponent },
   
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