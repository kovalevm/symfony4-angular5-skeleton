import {Component, OnInit} from '@angular/core';
import {User} from '../../models/user';
import {UsersService} from "../../services/users.service";
import {SnotifyService} from 'ng-snotify';
import {Router} from "@angular/router";
import {AuthService} from "../../services/auth.service";

@Component({
    selector: 'app-signup',
    templateUrl: './signup.component.html',
    styleUrls: ['./signup.component.css']
})
export class SignupComponent implements OnInit {
    public user: User;

    constructor(private snotifyService: SnotifyService,
                public usersService: UsersService,
                private router: Router,
                private as: AuthService) {
        this.user = new User();

        // TODO remove debug
        // const rand = Math.floor((Math.random() * 500) + 1);
        // this.user.email = `test-${rand}@users.com`;
        // this.user.name = `Ivan-${rand} Ivanov`;
        // this.user.password = "123456";
    }

    ngOnInit() {
        if (this.as.authId) {
            this.router.navigate(['']);
        }
    }

    register() {
        this.usersService.register(this.user).subscribe(
            data => {
                this.snotifyService.success("You have registered successful!");
                this.router.navigate(['signin', {email: data.body.email}]);
            },
            err => {
                console.error(err);
                this.snotifyService.error("Registration error!");
            },
            () => console.log('done register')
        );
    }
}
