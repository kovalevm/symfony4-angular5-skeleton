import { TestBed, inject } from '@angular/core/testing';

import { LsService } from './ls.service';

describe('LsService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [LsService]
    });
  });

  it('should be created', inject([LsService], (service: LsService) => {
    expect(service).toBeTruthy();
  }));
});
