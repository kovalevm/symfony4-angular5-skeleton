import {Injectable} from '@angular/core';
import {AppSettings} from "../app.settings";
import {HttpClient, HttpResponse} from '@angular/common/http';
import {Observable} from 'rxjs/Observable';
import {User} from "../models/user";
import {ApiService} from "./api.service";
import {catchError} from "rxjs/operators";
import {Token} from "../models/token";

@Injectable()
export class UsersService extends ApiService {
    api = 'users';

    constructor(protected http: HttpClient) {
        super(http);
    }

    public register(user: User): Observable<HttpResponse<User>> {
        const body = JSON.stringify(user);
        return this.http.post<User>(AppSettings.API_ENDPOINT + 'users/register', body, {observe: 'response'});
    }

    public login(user: User): Observable<HttpResponse<Token>> {
        const body = JSON.stringify(user);

        return this.http.post<Token>(AppSettings.API_ENDPOINT + 'users/login', body, {observe: 'response'})
            .pipe(catchError(this.handleError))
            ;
    }

    public get(id: number | string): Observable<HttpResponse<User>> {
        return this.GET(id);
    }

    public info(): Observable<HttpResponse<User>> {
        return this.GET();
    }
}
