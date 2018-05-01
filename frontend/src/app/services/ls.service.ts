import {Inject, Injectable} from '@angular/core';
import {PLATFORM_ID} from '@angular/core';
import {isPlatformBrowser, isPlatformServer} from '@angular/common';

@Injectable()
export class LsService {

    constructor(@Inject(PLATFORM_ID) private platformId: any,
                @Inject('LOCALSTORAGE') private localStorage: any) {
    }

    public set(key: string, value: any) {
        if (isPlatformBrowser(this.platformId)) {
            this.localStorage.setItem(key, value);
        }

        if (isPlatformServer(this.platformId)) {
        }
    }

    public remove(key: string) {
        if (isPlatformBrowser(this.platformId)) {
            this.localStorage.removeItem(key);
        }

        if (isPlatformServer(this.platformId)) {
        }
    }

    public get(key: string): any {
        if (isPlatformBrowser(this.platformId)) {
            return this.localStorage.getItem(key);
        }

        if (isPlatformServer(this.platformId)) {
            return null;
        }
    }

}
