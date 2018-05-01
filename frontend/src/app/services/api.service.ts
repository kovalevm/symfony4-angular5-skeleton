import {Injectable} from '@angular/core';
import {HttpClient, HttpErrorResponse} from '@angular/common/http';
import {ErrorObservable} from "rxjs/observable/ErrorObservable";
import {isArray, isObject} from "util";
import {AppSettings} from "../app.settings";
import {catchError} from "rxjs/operators";

@Injectable()
export abstract class ApiService {
    abstract api: string;

    constructor(protected http: HttpClient) {
    }

    protected GET(endpoint?: string | number, options?: any) {
        if (!isObject(options)) {
            options = {};
        }

        if (!options.hasOwnProperty("observe")) {
            options.observe = 'response';
        }

        // options.headers = {'Authorization': 'Bearer ' + this.as.authToken()};

        let url = AppSettings.API_ENDPOINT + this.api;

        if (endpoint) {
            url += "/" + endpoint;
        }

        return this.http
            .get(url, options)
            .pipe(catchError(this.handleError));
    }

    protected handleError(error: HttpErrorResponse) {
        if (isArray(error.error.errors) && error.error.errors.length > 0) {
            error.error.errors.forEach(err => {
                console.error('An error occurred:', err.title);
            });
        } else {
            // The backend returned an unsuccessful response code.
            // The response body may contain clues as to what went wrong,
            console.error(
                `Backend returned code ${error.status}, ` +
                `body was: ${error.error}`);
        }
        // return an ErrorObservable with a user-facing error message
        return new ErrorObservable(
            'Something bad happened; please try again later.');
    }
}
