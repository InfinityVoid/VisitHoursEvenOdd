describe("VisitHoursEvenOddUiTest", function () {
    this.timeout(0);

    var urlToTest = '?module=CoreHome&action=index&idSite=1&period=day&date=2013-01-23#/module=VisitHoursEvenOdd&action=menuGetEvenOddReport&idSite=1&period=day&date=2013-01-23';
    this.fixture = "Piwik\\Plugins\\VisitHoursEvenOdd\\Test\\Fixtures\\SimpleFixtureTrackFewVisits";

    testEnvironment.debug = "1";
    testEnvironment.save();

    it('should load a simple page by its module and action', function (done) {
        var screenshotName = 'simplePage';
        // will save image in "processed-ui-screenshots/WidgetizePageTest_simplePage.png"

        expect.screenshot(screenshotName).to.be.capture(function (page) {
            page.load(urlToTest);
        }, done);
    });
});