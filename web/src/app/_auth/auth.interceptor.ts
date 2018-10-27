import { HttpInterceptor, HttpRequest, HttpHandler, HttpUserEvent, HttpEvent } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { Router } from "@angular/router";
import {   Observable } from 'rxjs';
import { catchError, map, tap } from 'rxjs/operators';

@Injectable()
export class AuthInterceptor implements HttpInterceptor {

    constructor(private router: Router) { }

    intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        if (req.headers.get('No-Auth') == "True"){
            return next.handle(req.clone());}

        if (localStorage.getItem('userToken') != null) {
            debugger;
            const clonedreq = req.clone({
                headers: req.headers.set("Authorization", localStorage.getItem('userToken'))
            });
            return next.handle(clonedreq).pipe(
                tap(
                    succ => { },
                    err => {
                        debugger;
                        if (err.status === 401)
                            this.router.navigateByUrl('');
                    }
                    )
            )

        }
        else {
            debugger;
           // return next.handle(req.clone());
           this.router.navigateByUrl('');
        }
    }
}