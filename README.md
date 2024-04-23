# Parent Assignment


## How To Deploy

### For first time only !
- `docker compose up -d --build`
### From the second time onwards
- `docker compose up -d`


## Unit Test Coverage

- coverage report has been generated in `coverage-report` folder

## Adding New Data-Provider
- in `app/Enums/DataProvider.php` add new data provider to `cases` array, `getFileName` method , `getNames` method and `getReadableClasses` method
- in `app/Services/DataProvider/Providers` directory create new class that extends `AbstractDataProvider` like `DataProviderX` and `DataProviderY`
