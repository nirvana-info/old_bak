'''
Created on 2010-10-13

@author: christie.duan
'''
import PublicFunctions
import unittest


def Browser(self):
    PublicFunctions.my_wait_element(self,"//input[@class='searchBtn']")
    self.selenium.click("//input[@class='searchBtn']")

def Clear(self, type):
    PublicFunctions.my_wait_element(self,"//a[@name=\'%s\']/" % type)
    self.selenium.click("//a[@name=\'%s\']/" % type)

def smartsearch(self,searchkey):
    FunctionCommon.my_wait_element(self,"search_keywords")
    self.selenium.type("search_keywords", searchkey)
    self.selenium.click("//img[contains(@src,'/images/search-button4.png')]")
    
def Login(self, username, password):
    FunctionCommon.my_wait_element(self,"login_email")
    self.selenium.type("login_email",username)
    self.selenium.type("login_pass",password)
    self.selenium.click("LoginButton")
    