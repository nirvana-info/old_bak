

from selenium import selenium
import unittest

class TestBase(unittest.TestCase):
    def setUp(self):
        self.verificationErrors = []
        self.selenium = selenium("localhost", 4444, "*firefox3 E:/Program Files/Mozilla Firefox/firefox.exe", "http://www.truckchamp.com/")
        self.selenium.start()
        self.selenium.set_timeout("0")
        sel=self.selenium
        sel.open("/")  
        
        
    def tearDown(self):
##        self.selenium.stop()   ## comment this line, the browser won't be killed
        self.assertEqual([], self.verificationErrors)
  

                
