import React, {useEffect, useState} from "react";
import UserContext from ".";
import { getMe } from "../../services/api/user/user";

function UserProvider({children})
{
    const [userData, setUserData] = useState(undefined);
    useEffect(() =>{
        getMe().then(
            data => 
            {
                if (data === null)
                {
                    setUserData(null);
                }
                else
                {
                    setUserData(data)
                }
            }
            )
        }
    );
    return (
        <UserContext.Provider value={{userData}}>
            {children}
        </UserContext.Provider>
    );
}

export default UserProvider;