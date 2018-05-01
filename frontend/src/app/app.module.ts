import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';
import {AppComponent} from './app.component';
import {RouterModule, Routes} from '@angular/router';
import {SignupComponent} from './components/signup/signup.component';
import {IndexComponent} from './components/index/index.component';
import {SigninComponent} from './components/signin/signin.component';
import {UsersService} from "./services/users.service";
import {SnotifyModule, SnotifyService, ToastDefaults} from 'ng-snotify';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {HttpClientModule} from '@angular/common/http';
import {LsService} from "./services/ls.service";
import {AuthService} from "./services/auth.service";  // replaces previous Http service
import { NgHttpLoaderModule } from 'ng-http-loader/ng-http-loader.module';

const appRoutes: Routes = [
    {path: '', component: IndexComponent},
    {path: 'signin', component: SigninComponent},
    {path: 'signup', component: SignupComponent},
];

@NgModule({
    declarations: [
        AppComponent,
        SignupComponent,
        IndexComponent,
        SigninComponent
    ],
    imports: [
        BrowserModule,
        FormsModule,
        ReactiveFormsModule,
        HttpClientModule,
        RouterModule.forRoot(
            appRoutes,
            {enableTracing: false} // <-- debugging purposes only
        ),
        SnotifyModule,
        NgHttpLoaderModule
    ],
    providers: [
        {provide: 'LOCALSTORAGE', useFactory: getLocalStorage},
        LsService,
        {provide: 'SnotifyToastConfig', useValue: ToastDefaults},
        SnotifyService,
        UsersService,
        AuthService,
    ],
    bootstrap: [AppComponent]
})
export class AppModule {
}

export function getLocalStorage() {
    return (typeof window !== "undefined") ? window.localStorage : null;
}
