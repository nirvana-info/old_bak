'''
Created on 2011-02-25

@author: iris chen
'''
import unittest
import HTMLTestRunner 
from MoreSubCateOrSeriesTestCases import MoreSubCateOrSeriesTest
from MoreProdTestCases import MoreProdTest
from SmokingTestCases import SmokingTest
from SmartSearchTestCases import SmartSearchTest
from OpenSiteTestCases import OpenSiteTest


if __name__ == "__main__":
    fp = file('my_report.html', 'wb')
    runner = HTMLTestRunner.HTMLTestRunner(stream=fp, title='Quick Test', description='The test report of selenium')
##    runner.run(SmokingTest()) ## 10
##    runner.run(SmartSearchTest())  ## 7
    runner.run(MoreSubCateOrSeriesTest()) ## 6
##    runner.run(MoreProdTest()) ## 9
##    runner.run(OpenSiteTest()) ## 1

    
    
