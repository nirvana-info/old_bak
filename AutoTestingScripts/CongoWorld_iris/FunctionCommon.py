'''
Created on 2011-02-25

@author: iris chen
'''
import PublicFunctions
import unittest


def Browser(self):
    PublicFunctions.my_wait_element(self,"//input[@class='searchBtn']")
    self.selenium.click("//input[@class='searchBtn']")

def Clear(self):
    self.selenium.click("link=Clear All")
    self.selenium.wait_for_page_to_load("10000")

def smartsearch(self,searchkey):  
    PublicFunctions.my_wait_element(self,"search_keywords")
    self.selenium.type("search_keywords", searchkey)    
    self.selenium.click("//img[contains(@src,'http://www.lofinc.net/images/smart-search.png')]")

    
def Login(self, username, password):
    PublicFunctions.my_wait_element(self,"login_email")
    self.selenium.type("login_email",username)
    self.selenium.type("login_pass",password)
    self.selenium.click("LoginButton")
    
