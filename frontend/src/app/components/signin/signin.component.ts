import {Component, OnInit} from '@angular/core';
import {SnotifyService} from "ng-snotify";
import {UsersService} from "../../services/users.service";
import {User} from "../../models/user";
import {AuthService} from "../../services/auth.service";
import {Router, ActivatedRoute} from '@angular/router';

@Component({
    selector: 'app-signin',
    templateUrl: './signin.component.html',
    styleUrls: ['./signin.component.css']
})
export class SigninComponent implements OnInit {
    public user: User;

    constructor(private snotifyService: SnotifyService,
                public usersService: UsersService,
                public authService: AuthService,
                private route: ActivatedRoute,
                private router: Router) {

        this.user = new User();
    }

    ngOnInit() {
        const email = this.route.snapshot.paramMap.get('email');
        if (!!email) {
            this.user.email = email;
        }
    }

    login() {
        this.usersService.login(this.user).subscribe(
            resp => {
                this.authService.saveToken(resp.body.token);
                this.authService.loadUserInfo();
                this.snotifyService.success("You have login successful!");
                this.router.navigate(['']);
            },
            err => this.snotifyService.error("Login error!")
        );
    }

}
