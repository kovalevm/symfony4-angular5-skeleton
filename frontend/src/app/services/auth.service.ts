import {EventEmitter, Injectable, OnInit} from '@angular/core';
import {User} from "../models/user";
import {LsService} from "./ls.service";
import {Router} from "@angular/router";
import {AppSettings} from "../app.settings";
import {HttpClient, HttpResponse} from "@angular/common/http";
import {Observable} from 'rxjs/Observable';

@Injectable()
export class AuthService {
    public static TOKEN_KEY = 'ApiToken';
    private _token: string;
    private _user: User;

    dispatcher: EventEmitter<any> = new EventEmitter();

    constructor(protected ls: LsService,
                protected http: HttpClient,
                private router: Router) {
        this.loadUserInfo();
    }

    public loadUserInfo(): void {
        this._token = this.loadToken();
        if (!this._token) {
            console.warn("Token is empty");
            return;
        }

        this.request().subscribe(
            resp => {
                console.log("Auth loaded!");
                this._user = resp.body;
                this.dispatcher.emit();
            },
            err => {
                console.log("Auth failed!");
                this.router.navigate(['/signin']);
            }
        );
    }

    public logout(): void {
        this.ls.remove(AuthService.TOKEN_KEY);
        this._user = null;
        this.dispatcher.emit();
    }

    emitMessageEvent(name: string, data: any) {
        const message = "messagesssss-emitt";
        this.dispatcher.emit(message);
    }

    getEmitter() {
        return this.dispatcher;
    }

    private request(): Observable<HttpResponse<User>> {
        return this.http.get<User>(AppSettings.API_ENDPOINT + 'users/summary', {
            headers: {'Authorization': 'Bearer ' + this._token},
            observe: 'response'
        });
    }

    public saveToken(token: string) {
        this._token = token;
        this.ls.set(AuthService.TOKEN_KEY, token);
    }

    public loadToken(): string {
        return this.ls.get(AuthService.TOKEN_KEY);
    }

    get authUser(): User {
        return this._user;
    }

    public get authToken(): string {
        return this._token;
    }

    public get authId(): number {
        if (this._user != null) {
            return this._user.id;
        }
    }

    public get authName(): string {
        if (this._user != null) {
            return this._user.name;
        }
    }
}
